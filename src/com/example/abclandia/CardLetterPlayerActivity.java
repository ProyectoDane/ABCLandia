package com.example.abclandia;

import java.util.List;

import android.app.Activity;
import android.content.res.Configuration;
import android.graphics.Bitmap;
import android.graphics.PixelFormat;
import android.graphics.Point;
import android.os.Bundle;
import android.view.Display;
import android.view.Gravity;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.GridView;
import android.widget.ImageView;

import com.example.abclandia.audio.Audio;
import com.example.abclandia.graphics.CardView;
import com.example.abclandia.graphics.CompleteCardRenderer;
import com.example.abclandia.graphics.Renderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.utils.Util;

public class CardLetterPlayerActivity extends Activity implements
		View.OnTouchListener {

	private List<Card> data;
	private Audio mAudio;
	private GridView mGridView;
	private WindowManager mWindowManager;
	private int mCenterScreenX, mCenterScreenY;
	private LetterPlayerAnimator mDragShadowAnimator;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);
		mWindowManager = (WindowManager) getSystemService("window");

		setScreenPointSenter();

		Configuration config = getResources().getConfiguration();
		
		if (config.smallestScreenWidthDp >= 720) {
			Renderer.TEXT_LETTER_SIZE = 19;
			Renderer.TEXT_WORD_SIZE = 17;
		} else if (config.smallestScreenWidthDp >= 600) {
			Renderer.TEXT_LETTER_SIZE = 15;
			Renderer.TEXT_WORD_SIZE = 13;
		}
		
		data = GameDataStructure.LoadDataCard();

		mAudio = new Audio(this);
		mAudio.loadWordSounds(data);

		setContentView(R.layout.card_letter_player_activity);

		mGridView = (GridView) findViewById(R.id.gridView);
		mGridView.setAdapter(new CardViewAdapter(data, this,
				new CompleteCardRenderer(this),
				R.layout.card_letter_player_card_view, true));

		mDragShadowAnimator = new LetterPlayerAnimator(this);

	}

	@Override
	public boolean onTouch(View v, MotionEvent event) {

		final int action = event.getAction();

		if (action == MotionEvent.ACTION_DOWN) {
			// mGridView.setAlpha(0.1f);
			int motionDownX = (int) event.getRawX();
			int motionDownY = (int) event.getRawY();

			Bitmap bitmapCard = Util.getViewBitmap(v);
			int[] loc = new int[2];
			v.getLocationOnScreen(loc);

			int registrationX = motionDownX - loc[0];
			int registrationY = motionDownY - loc[1];

			int bitmapSizeX = bitmapCard.getWidth();
			int bitmapSizeY = bitmapCard.getHeight();
			//

			ImageView iv = new ImageView(this);
			iv.setImageBitmap(bitmapCard);

			WindowManager.LayoutParams lp;
			int pixelFormat;

			pixelFormat = PixelFormat.TRANSLUCENT;

			lp = new WindowManager.LayoutParams(
					ViewGroup.LayoutParams.WRAP_CONTENT,
					ViewGroup.LayoutParams.WRAP_CONTENT, loc[0], loc[1],
					WindowManager.LayoutParams.TYPE_APPLICATION_SUB_PANEL,
					WindowManager.LayoutParams.FLAG_LAYOUT_IN_SCREEN
							| WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS
					/* | WindowManager.LayoutParams.FLAG_ALT_FOCUSABLE_IM */,
					pixelFormat);
			// lp.token = mStatusBarView.getWindowToken();
			lp.gravity = Gravity.LEFT | Gravity.TOP;
			lp.token = null;
			lp.setTitle("DragView");

			mWindowManager.addView(iv, lp);

			CardView view = (CardView) v;
			mDragShadowAnimator.animate(iv, mGridView, view, loc[0],
					mCenterScreenX - bitmapSizeX / 2, loc[1], mCenterScreenY
							- bitmapSizeY / 2, bitmapSizeX, bitmapSizeX);

			

		}

		return false;

	}

	public void reproduceSoundCard(CardView cardView) {
		mAudio.playSoundWord(cardView.getCardId());
	}

	private void setScreenPointSenter() {

		Display display = getWindowManager().getDefaultDisplay();
		Point size = new Point();
		display.getSize(size);
		mCenterScreenX = size.x / 2;
		mCenterScreenY = size.y / 2;

	}

	
}
